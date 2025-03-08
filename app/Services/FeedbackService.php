<?php

namespace App\Services;

use App\DTO\Feedback\FeedbackDTO;
use App\Models\Feedback;
use App\Repositories\FeedbackRepository;

class FeedbackService
{
    private FeedbackRepository $repository;

    /**
     * FeedbackService constructor.
     * @param FeedbackRepository $repository
     */
    public function __construct(FeedbackRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FeedbackDTO $dto
     * @return Feedback|null
     */
    public function create( FeedbackDTO $dto ): ?Feedback
    {
        return $this->repository->store( $dto );
    }
}