<?php

namespace App\Http\Controllers;

use App\DTO\Feedback\FeedbackDTO;
use App\Http\Requests\Feedback\CreateFeedbackRequest;
use App\Notifications\SendFeedbackNotification;
use App\Services\FeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class FeedbackController extends Controller
{
    private FeedbackService $feedback_service;

    /**
     * FeedbackController constructor.
     * @param FeedbackService $feedback_service
     */
    public function __construct(FeedbackService $feedback_service)
    {
        $this->feedback_service = $feedback_service;
    }

    /**
     * @param CreateFeedbackRequest $request
     * @return JsonResponse
     */
    public function store( CreateFeedbackRequest $request ): JsonResponse
    {
        $feedback_dto = FeedbackDTO::fromRequest( $request );
        $feedback = $this->feedback_service->create( $feedback_dto );
        if ( $feedback === null ) {
            return response()->json( [ 'status' => 'error' ], 400 );
        }

        Notification::route( 'mail', config( 'mail.feedback.address' ) )
            ->notify( new SendFeedbackNotification( $feedback_dto ) );

        return response()->json( [ 'status' => 'success' ] );
    }
}
