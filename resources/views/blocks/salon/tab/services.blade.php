<?php
use App\Enums\SpecializationTypes;
/** @var \App\Models\Contact $salon */
/** @var \Illuminate\Support\Collection $services */
?>

<div class="tab-pane fade" id="services">
    <h2>Услуги</h2>
    <div class="accordion" id="accordionServices">

        @includeWhen(
            /*( ( $salon->specialization?->type ?? 0 ) & SpecializationTypes::TATTOO ) && */$services->filter( fn ( $dto ) => $dto->type === SpecializationTypes::TATTOO && $dto->status === 1 )->isNotEmpty(),
            'blocks.salon.item.price',
            [ 'caption' => 'Татуировки', 'type' => SpecializationTypes::TATTOO, 'prices' => $services ]
        )

        @includeWhen(
            /*( ( $salon->specialization?->type ?? 0 ) & SpecializationTypes::TATUAJE ) && */$services->filter( fn ( $dto ) => $dto->type === SpecializationTypes::TATUAJE && $dto->status === 1 )->isNotEmpty(),
            'blocks.salon.item.price',
            [ 'caption' => 'Татуаж', 'type' => SpecializationTypes::TATUAJE, 'prices' => $services ]
        )

        @includeWhen(
            /*( ( $salon->specialization?->type ?? 0 ) & SpecializationTypes::PIERCING ) && */$services->filter( fn ( $dto ) => $dto->type === SpecializationTypes::PIERCING && $dto->status === 1 )->isNotEmpty(),
            'blocks.salon.item.price',
            [ 'caption' => 'Пирсинг', 'type' => SpecializationTypes::PIERCING, 'prices' => $services ]
        )

        @includeWhen(
            /*( ( $salon->specialization?->type ?? 0 ) & SpecializationTypes::OTHER ) && */$services->filter( fn ( $dto ) => $dto->type === SpecializationTypes::OTHER && $dto->status === 1 )->isNotEmpty(),
            'blocks.salon.item.price',
            [ 'caption' => 'Другое', 'type' => SpecializationTypes::OTHER, 'prices' => $services ]
        )

    </div>
</div>
