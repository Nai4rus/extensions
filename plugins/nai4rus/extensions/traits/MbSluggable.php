<?php
namespace Nai4rus\Extensions\Traits;

use October\Rain\Database\Traits\Sluggable;
use October\Rain\Support\Facades\Str;

trait MbSluggable
{
    use Sluggable;

    /**
     * Sets a single slug attribute value. Update substr function to mb_substr
     * @param string $slugAttribute Attribute to populate with the slug.
     * @param mixed $sourceAttributes Attribute(s) to generate the slug from.
     * Supports dotted notation for relations.
     * @param int $maxLength Maximum length for the slug not including the counter.
     * @return string The generated value.
     */
    public function setSluggedValue($slugAttribute, $sourceAttributes, $maxLength = 240)
    {
        if (!isset($this->{$slugAttribute}) || !strlen($this->{$slugAttribute})) {
            if (!is_array($sourceAttributes)) {
                $sourceAttributes = [$sourceAttributes];
            }

            $slugArr = [];
            foreach ($sourceAttributes as $attribute) {
                $slugArr[] = $this->getSluggableSourceAttributeValue($attribute);
            }

            $slug = implode(' ', $slugArr);
            $slug = mb_substr($slug, 0, $maxLength);
            $slug = Str::slug($slug, $this->getSluggableSeparator());
        }
        else {
            $slug = $this->{$slugAttribute};
        }

        return $this->{$slugAttribute} = $this->getSluggableUniqueAttributeValue($slugAttribute, $slug);
    }

}