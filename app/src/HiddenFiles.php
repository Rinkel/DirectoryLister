<?php

namespace App;

use Tightenco\Collect\Support\Collection;

class HiddenFiles extends Collection
{
    /** {@inheritdoc} */
    protected function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);
    }

    /**
     * Create a new HiddenFiles collection object.
     *
     * @param \App\Config $config
     */
    public static function fromConfig(Config $config): self
    {
        $items = $config->get('hidden_files');

        if (is_readable($config->get('hidden_files_list'))) {
            $items = array_merge($items, file(
                $config->get('hidden_files_list'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            ));
        }

        if ($config->get('hide_app_files')) {
            $items = array_merge($items, $config->get('app_files'));
        }

        return new static(array_unique($items));
    }
}
