<?php

const CSRF_NAME = 'csrf_token';
const METHOD_NAME = '_method';

const REDIRECT_INDEX = 'redirect_data';

const MAX_IMAGE_COUNT = 4;
const DEFAULT_THUMBNAIL = '/img/news.jpg';

enum NewsMode {
    case EDIT;
    case VIEW;
    case CREATE;
}

enum CardSize {
    case SMALL;
    case WIDE;
}
