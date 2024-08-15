<?php

namespace App\Support;

use App\Support\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class DTO
{
    use ApiResponseTrait;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_filter((array) $this, fn($attribute) => !is_null($attribute));
    }

    /**
     * Validate the data based on DTO-specific rules.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator|null
     */
    protected static function validate(array $data)
    {
        $validator = Validator::make($data, static::rules());

        if ($validator->fails()) {
            return $validator;
        }

        return null;
    }

    /**
     * Define validation rules for the DTO.
     *
     * @return array
     */
    abstract protected static function rules(): array;

    /**
     * Create a DTO instance from request data.
     *
     * @param array $data
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function fromRequest(array $data)
    {
        $validator = static::validate($data);
        if ($validator && $validator->fails()) {
            $errors = $validator->errors();
            throw new \InvalidArgumentException('Invalid data', 0, new \Exception($errors->toJson()));
        }

        return new static($data);
    }
}
