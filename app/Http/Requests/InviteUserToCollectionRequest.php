<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class InviteUserToCollectionRequest extends FormRequest
{
    public ?User $invitedUser;

    public function authorize(): bool
    {
        return $this->user()->can('update', $this->collection);
    }

    protected function prepareForValidation()
    {
        if ($this->missing('email')) {
            return;
        }

        $this->invitedUser = User::firstWhere('email', $this->input('email'));
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'bail',
                function ($attribute, $value, $fail) {
                    if ($this->invitedUser === null) {
                        $fail('A user with this email address was not found.');
                    }
                },
                function ($attribute, $value, $fail) {
                    if ($this->collection->users->contains($this->invitedUser)) {
                        $fail('This user has already been added to this collection.');
                    }
                },
            ],
        ];
    }
}
