<?php

const CSRF_NAME = 'csrf_token';
const METHOD_NAME = '_method';

const REDIRECT_INDEX = 'redirect_data';

const MAX_IMAGE_COUNT = 4;
const DEFAULT_THUMBNAIL = '/img/news.jpg';

const CSRF_NEWS_CREATE = 'news-create';
const CSRF_NEWS_DELETE = 'news-delete';
const CSRF_NEWS_EDIT = 'news-edit';
const CSRF_SIGNUP = 'signup';
const CSRF_LOGIN = 'login';
const CSRF_LOGOUT = 'logout';

enum NewsMode {
    case EDIT;
    case VIEW;
    case CREATE;
}

enum CardSize {
    case SMALL;
    case WIDE;
}
