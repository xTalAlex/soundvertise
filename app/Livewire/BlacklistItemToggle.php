<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\Blacklistable;
use Livewire\Component;

class BlacklistItemToggle extends Component
{
    public $action;

    public $model_type;

    public $model_id;

    public function rules()
    {
        return [
            'action' => ['required', 'string'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'integer'],
        ];
    }

    public function toggle()
    {
        $this->withValidator(function ($validator) {
            $validator->after(function ($validator) {
                $action = strtolower($this->input('action') ?? '');
                $modelType = ucfirst(strtolower($this->input('model_type') ?? ''));
                $modelId = $this->input('model_id');

                if ($action && ! in_array($action, ['add', 'remove'])) {
                    return $validator->errors()->add('action', 'Invalid action.');
                }

                if ($modelType && $modelId) {
                    $modelClass = 'App\\Models\\'.$modelType;

                    if (! class_exists($modelClass)) {
                        return $validator->errors()->add('model_type', 'Invalid model type.');
                    }

                    // Check if the model is blacklistable by checking if it uses Blacklistable trait
                    if (! in_array(Blacklistable::class, class_uses($modelClass), true)) {
                        return $validator->errors()->add('model_type', 'The specified model type is not blocklistable.');
                    }

                    // Check if the specified model instance exists
                    if (! $modelClass::find($modelId)) {
                        return $validator->errors()->add('model_id', 'The specified model ID does not exist.');
                    }
                }
            });
        })->this->validate();

        $action = strtolower($this->action);
        $isAddAction = $action === 'add';
        $modelType = ucfirst(strtolower($this->model_type));
        $modelId = $this->model_id;
        $modelClass = 'App\\Models\\'.$modelType;

        if ($modelClass === User::class && $modelId == $this->user?->id) {
            return response()->json(['message' => 'You cannot blacklist yourself.'], 400);
        }

        $isAlreadyBlacklisted = $this->user->blacklistedEntities($modelClass)->where('blocklistable_id', $modelId)->exists();

        if ($isAddAction && ! $isAlreadyBlacklisted) {
            $this->user->blacklistedEntities($modelClass)->syncWithoutDetaching([$modelId]);
        } elseif (! $isAddAction && $isAlreadyBlacklisted) {
            $detached = $this->user->blacklistedEntities($modelClass)->detach($modelId);

            if (! $detached) {
                return response()->json(
                    ['error' => "Failed to remove the {$modelType} from blacklist."],
                );
            }
        }

        return response()->json([
            'message' => "Model {$action}ed successfully.",
            'blacklisted' => $isAddAction,
        ]);
    }

    public function render()
    {
        return view('livewire.blacklist-item-toggle');
    }
}
