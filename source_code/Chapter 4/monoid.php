<?php

class Monoid {

    public function __construct($value) {

        $this->value = $value;

    }

		public function concat($to) {

        return new Monoid(array_merge($to->value, $this->value));

    }

};
