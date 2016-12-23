<?php

if (PHP_MAJOR_VERSION == 7) {
    throw new ParseError('PHP7 ParseError');
} else {
    throw new Exception('PHP5 Exception');
}
