<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(TicketStatus::cases());

        return [
            'reference'          => 'OSS-' . strtoupper(Str::random(16)),
            'customer_name'      => fake()->name(),
            'email'              => fake()->safeEmail(),
            'phone'              => fake()->numerify('0#########'),
            'ticket_description' => fake()->paragraph(),
            'status'             => $status,
            'opened_at'          => $status === TicketStatus::New ? null : fake()->dateTimeBetween('-5 days', 'now'),
        ];
    }
}
