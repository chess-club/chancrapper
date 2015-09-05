<?php namespace Chancrapper;

use Illuminate\Database\Eloquent\Model;

class Scrape extends Model {
	protected $table = 'scrape';

	public function getFullSizeUrlAttribute() {
		return env('IMAGE_BASE_URL').$this->locnam;
	}

	public function getThumbnailName() {
		return str_replace(".", "_thumb.", $this->locnam);
	}

	public function getThumbnailUrlAttribute() {
		return env('IMAGE_BASE_URL').$this->getThumbnailName();
	}

	public function getFiletypeAttribute() {
		return pathinfo($this->locnam, PATHINFO_EXTENSION);
	}

	public function getFuukaHashAttribute() {
		return str_replace(['+', '/', '='], ['-', '_', ''],
			base64_encode(hex2bin($this->hash)));
	}

	static function search($input) {
		$query = self::query();

		$textparts = [];
		foreach (explode(' ', $input) as $part) {
			if (preg_match("/^([a-z0-9]+):(.*)$/", $part, $matches) === 1) {
				list($part_, $key, $value) = $matches;
				if ($key === 'md5') {
					$query = $query->where('hash', strtolower($value));
					continue;
				} else if ($key === 'nick' || $key === 'url') {
					$value = str_replace('https://', '', $value);
					$query = $query->where($key, 'like', '%'.$value.'%');
					continue;
				} else if ($key === 'http' || $key === 'https') {
					$query = $query->where('url', 'like', '%'.$value.'%');
					continue;
				}
			}
			if (preg_match("/^[0-9a-fA-F]{32}$/", $part) === 1) {
				$query = $query->where('hash', strtolower($part));
				continue;
			}

			/* something else */
			$query->where(function($subquery) use ($part) {
				$subquery->where('msg', 'like', '%'.$part.'%')
				       ->orWhere('url', 'like', '%'.$part.'%')
				       ->orWhere('nick', 'like', $part);
			});
		}

		return $query;
	}
}
