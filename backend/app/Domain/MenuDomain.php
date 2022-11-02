<?php

namespace App\Domain;

use App\Models\Event;

class MenuDomain
{
    /**
     * Copy all the menu sections and menu items from one event to another
     *
     * @param  Event  $from
     * @param  Event  $to
     */
    public static function copyMenuFromEvent(Event $from, Event $to)
    {
        $sections = $from->menuSections()
            ->with('menuItems')
            ->orderBy('order')
            ->get();

        foreach ($sections as $section) {
            $items = $section->menuItems
                ->map(fn ($item) => $item->only(['name', 'price']))
                ->toArray();

            $data = $section->only(['name', 'order']);

            $newSection = $to->menuSections()->create($data);

            $newSection->menuItems()->createMany($items);
        }
    }
}
