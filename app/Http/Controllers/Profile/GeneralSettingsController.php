<?php

namespace App\Http\Controllers\Profile;

use App\DTO\Contact\ContactDTO;
use App\DTO\File\FileDTO;
use App\Enums\FileSubtypes;
use App\Http\Requests\Profile\CheckAliasRequest;
use App\Http\Requests\Profile\UpdateGeneralRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ContactService;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class GeneralSettingsController extends BaseProfileController
{
    /**
     * GeneralSettingsController constructor.
     * @param ContactService $contact_service
     * @param FileService $file_service
     */
    public function __construct(
        private ContactService $contact_service,
        private FileService $file_service )
    {
        parent::__construct();
    }

    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithCover( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.general.edit', [
            'user'       => $this->auth_user,
            'contact_id' => $contact_id,
            'salon'      => $salon,
            'title'      => 'Общая информация | ' . $salon->name . ' | Личный кабинет'
        ] );
    }

    /**
     * @param UpdateGeneralRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function update( UpdateGeneralRequest $request, int $contact_id ): RedirectResponse
    {
        $salon = $this->contact_service->findWithCover( $contact_id );
        if ( $salon === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        if ( $this->contact_service->update( $contact_id, ContactDTO::fromRequest( $request ) ) === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось изменить данные' ] );
        }

        if ( $request->hasFile( 'cover' ) ) {
            $uploaded_file = $this->file_service->uploadFile( $request->file( 'cover' ) );
            if ( $uploaded_file === null ) {
                return back()->withInput()->withErrors( [ 'message' => 'Не загрузить файл' ] );
            }

            $salon->cover()->delete();

            $dto = FileDTO::fromFile( $uploaded_file, FileSubtypes::COMMON );
            if ( $this->file_service->create( $dto, $salon ) === null ) {
                return back()->withInput()->withErrors( [ 'message' => 'Не удалось изменить обложку' ] );
            }
        }

        return redirect()->route( 'account.profile.general.edit', [
            'contact_id' => $contact_id
        ] )->with( 'success', 'Общая информация по салону успешно обновлена' );
    }

    /**
     * @param CheckAliasRequest $request
     * @return JsonResponse
     */
    public function checkAlias( CheckAliasRequest $request ): JsonResponse
    {
        if ($this->contact_service->isAliasAvailable($request->get('alias'))) {
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0]);
    }
}
