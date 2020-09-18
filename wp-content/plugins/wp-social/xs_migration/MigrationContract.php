<?php

namespace WpSocialXs\XsMigration;


interface MigrationContract {

	public function input($txtDomain, $versionFrom, $versionTo);

	public function output(array $data);
}