<?php

namespace App\Repositories;

use App\DTO\Feedback\FeedbackDTO;
use App\Models\Feedback;

class FeedbackRepository
{
    /**
     * @param FeedbackDTO $dto
     * @return Feedback|null
     */
    public function store( FeedbackDTO $dto ): ?Feedback
    {
        $feedback = new Feedback();
        $feedback->name    = $dto->name;
        $feedback->phone   = $dto->phone;
        $feedback->email   = $dto->email;
        $feedback->message = $dto->message;

        return $feedback->save() ? $feedback : null;
    }
}