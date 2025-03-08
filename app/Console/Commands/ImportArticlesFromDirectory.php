<?php

namespace App\Console\Commands;

use App\DTO\Article\ArticleDTO;
use App\DTO\File\FileDTO;
use App\Filters\UserFilter;
use App\Helpers\AliasHelper;
use App\Models\Article;
use App\Models\User;
use App\Services\ArticleService;
use App\Services\FileService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImportArticlesFromDirectory extends Command
{
    private const FIELD_ARTICLE_TITLE          = 0;
    private const FIELD_ARTICLE_TEXT_FILE_PATH = 1;
    private const FIELD_ARTICLE_PHOTO_PATH     = 2;

    private const FILE_FIELDS_COUNT = 3;

    /**
     * @var string
     */
    protected $signature = 'import:articles {file} {directory}';

    /**
     * @var string
     */
    protected $description = 'Import articles from settings in selected file';

    private UserService $user_service;

    private ArticleService $article_service;

    private FileService $file_service;

    /**
     * @return void
     */
    public function __construct(
        UserService $user_service,
        ArticleService $article_service,
        FileService $file_service )
    {
        parent::__construct();

        $this->user_service    = $user_service;
        $this->article_service = $article_service;
        $this->file_service    = $file_service;
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $file = $this->argument( 'file' );
        if ( File::exists( $file ) === false ) {
            $this->error( 'Settings file doesn\'t exists' );

            return 1;
        }

        $directory = $this->argument( 'directory' ) . '/';
        if ( File::isDirectory( $directory ) === false ) {
            $this->error( 'Files directory doesn\'t exists' );

            return 2;
        }

        $file_lines = file( $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

        // простая проверка файла на количество столбцов в csv
        if ( count( explode( ';', $file_lines[0] ) ) !== self::FILE_FIELDS_COUNT ) {
            $this->error( 'File incorrect [wrong fields count]' );
            return 2;
        }

        /** @var UserFilter $user_filter */
        $user_filter = App::make( UserFilter::class );
        $user_filter->setCustomFields( [ 'role' => config( 'roles.admin' ) ] );

        $user = $this->user_service->search( $user_filter )->first();
        if ( $user === null ) {
            $this->error( 'Undefined admin user' );

            return 3;
        }

        foreach ( $file_lines as $line ) {
            $line_fields = str_getcsv( iconv( 'cp1251', 'utf-8', $line ), ';' );

            $this->parseSettingsLine( $line_fields, $directory, $user );
        }

        return 0;
    }

    /**
     * @param array $settings_line
     * @param string $files_directory
     * @param User $user
     */
    private function parseSettingsLine( array $settings_line, string $files_directory, User $user ): void
    {
        if ( !isset( $settings_line[ self::FIELD_ARTICLE_TEXT_FILE_PATH ] ) ) {
            $this->warn( 'undefined text file path in settings line' );
            return;
        }

        $article = $this->addArticle( $settings_line, $files_directory, $user );
        if ( $article === null ) {
            $this->warn( 'article don\'t added' );
            return;
        }

        if ( !empty( $settings_line[ self::FIELD_ARTICLE_PHOTO_PATH ] ) ) {
            $this->addArticlePhoto( $settings_line[ self::FIELD_ARTICLE_PHOTO_PATH ], $files_directory, $article, $user );
        }
    }

    /**
     * @param array $settings_line
     * @param string $files_directory
     * @param User $user
     * @return Article|null
     */
    private function addArticle( array $settings_line, string $files_directory, User $user ): ?Article
    {
        $article_text_file = $files_directory . $settings_line[ self::FIELD_ARTICLE_TEXT_FILE_PATH ];
        if ( !file_exists( $article_text_file ) ) {
            $this->warn( 'File text ' . $article_text_file . ' doesn\'t exists' );
            return null;
        }

        $content = file_get_contents( $article_text_file );
        if ( !$content ) {
            return null;
        }

        /** @var ArticleDTO $dto */
        $dto = App::make( ArticleDTO::class );
        $dto->title        = $settings_line[ self::FIELD_ARTICLE_TITLE ];
        $dto->user_id      = $user->id;
        $dto->alias        = AliasHelper::getFromString( $settings_line[ self::FIELD_ARTICLE_TITLE ] );
        $dto->content      = iconv( 'cp1251', 'utf-8', $content );
        $dto->description  = $dto->title;
        $dto->published_at = Carbon::now();

        return $this->article_service->create( $dto );
    }

    /**
     * @param string $image_file
     * @param string $files_directory
     * @param Article $article
     * @param User $user
     */
    private function addArticlePhoto( string $image_file, string $files_directory, Article $article, User $user ): void
    {
        $image_file = $files_directory . $image_file;
        if ( !file_exists( $image_file ) ) {
            $this->warn( 'File photo ' . $image_file . ' doesn\'t exists' );
            return;
        }

        $file_extension = pathinfo( $image_file, PATHINFO_EXTENSION );
        if ( in_array( $file_extension, [ 'jpeg', 'jpg', 'png' ], true ) ) {
            $original_file_name = md5_file( $image_file ) . '.' . $file_extension;
            $filepath_original = Storage::path( config( 'image.original.path' ) ) . $original_file_name;
            copy( $image_file, $filepath_original );

            $image = Image::make( $filepath_original );

            $dto = new FileDTO();
            $dto->original         = $original_file_name;
            $dto->size             = $image->filesize();
            $dto->mime_type        = $image->mime();
            $dto->user_id          = $user->id;

            $this->file_service->create( $dto, $article );
        }
    }
}
