<?php

namespace Comitium5\MercuriumWidgetsBundle\Constants;

/**
 * Class EntityConstants
 *
 * @package Comitium5\MercuriumWidgetsBundle\Constants
 */
class EntityConstants
{
    // Entity fields keys
    const ASSET_FIELD_KEY = "asset";
    const AUTHOR_FIELD_KEY = "author";
    const CATEGORIES_FIELD_KEY = "categories";
    const FIELDS_FIELD_KEY = "fields";
    const ID_FIELD_KEY = "id";
    const MEDIA_CLASSES_FIELD_KEY = "mediaClasses";
    const SEARCHABLE_FIELD_KEY = "searchable";
    const SOCIAL_NETWORKS_FIELD_KEY = "socialNetworks";
    const SORT_FIELD_KEY = "sort";
    const SUBSCRIPTIONS_FIELD_KEY = "subscriptions";
    const TAGS_FIELD_KEY = "tags";
    const TYPE_FIELD_KEY = "type";

    // Sort fields key
    const PUBLISHED_DESC = "publishedAt desc";

    // Query fields key
    const LIMIT_FIELD_KEY = "limit";

    // Assets fields keys
    const IMAGE_FIELD_KEY = "image";
    const VIDEO_FIELD_KEY = "video";
    const AUDIO_FIELD_KEY = "audio";

    // Media classes keys
    const HAS_AUDIO = "has-audio";
    const HAS_CATEGORY = "has-category-";
    const HAS_IMAGE = "has-image";
    const HAS_NO_IMAGE = "has-no-image";
    const HAS_VIDEO = "has-video";
}