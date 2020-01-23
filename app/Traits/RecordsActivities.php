<?php

namespace App\Traits;

trait RecordsActivities
{
    /**
     * Дополнительный класс для загрузчика класса
     */
    public static function bootRecordsActivities()
    {
        if (!auth()->check()) {
            return;
        }
        foreach (static::getActivityEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    /**
     * Получение массива событий для которых требуется сохранение активности
     *
     * @return array
     */
    protected static function getActivityEvents()
    {
        return ['created'];
    }

    /**
     * @param $event
     * @throws \ReflectionException
     */
    protected function recordActivity(string $event)
    {
        $this->activities()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * Реляция для актиностей
     *
     * @return mixed
     */
    public function activities()
    {
        return  $this->morphMany('App\Activity', 'subject');
    }

    /**
     * Получение типа активности
     *
     * @param string $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType(string $event): string
    {
        /** @var string $type */
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}
