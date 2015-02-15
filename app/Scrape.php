<?php namespace Chancrapper;

use Illuminate\Database\Eloquent\Model;

class Scrape extends Model {
	protected $table = 'scrape';

	public function getFullSizeUrlAttribute() {
		return $_ENV['IMAGE_BASE_URL'].$this->locnam;
	}

	public function getThumbnailName() {
		return str_replace(".", "_thumb.", $this->locnam);
	}

	public function getThumbnailUrlAttribute() {
		return $_ENV['IMAGE_BASE_URL'].$this->getThumbnailName();
	}

	public function getFiletypeAttribute() {
		return pathinfo($this->locnam, PATHINFO_EXTENSION);
	}
}
