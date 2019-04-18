<?php
/**
 * File containing the class \Sensei_LMS_Beta\Tests\Unit_Tests\Abstract_Updater.
 *
 * @package sensei-lms-beta/Tests
 * @since   1.0.0
 */

namespace Sensei_LMS_Beta\Tests\Unit_Tests;

use Sensei_LMS_Beta\Tests\Framework\Base_Test;
use Sensei_LMS_Beta\Tests\Framework\Updater_Shim;
use Sensei_LMS_Beta\Tests\Framework\Source_Shim;
use Sensei_LMS_Beta\Updater\Abstract_Updater;
use Sensei_LMS_Beta\Updater\Plugin_Package;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class containing base test.
 *
 * @class \Sensei_LMS_Beta\Tests\Unit_Tests\Abstract_Updater
 */
class Test_Abstract_Updater extends Base_Test {
	/**
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_versions
	 */
	public function testGetVersionsSimple() {
		$updater = $this->getSimpleUpdater();

		$result = $updater->get_versions( null, true );

		$versions = [ '1.1.1-beta.1', '1.1.0-rc.2', '1.1.0-rc.1', '1.1.0-beta.2', '1.1.0-beta.1', '1.0.1', '1.0.1-beta.1', '1.0.0' ];
		$this->assertEquals( $versions, array_keys( $result ) );
	}

	/**
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_latest_channel_release
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_versions
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_beta_channel
	 */
	public function testGetLatestChannelReleaseBeta() {
		$updater = $this->getSimpleUpdater();

		$latest = $updater->get_latest_channel_release( Abstract_Updater::CHANNEL_BETA );

		$this->assertTrue( $latest instanceof Plugin_Package );
		$this->assertEquals( '1.1.1-beta.1', $latest->get_version() );
	}

	/**
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_latest_channel_release
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_versions
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_rc_channel
	 */
	public function testGetLatestChannelReleaseRC() {
		$updater = $this->getSimpleUpdater();

		$latest = $updater->get_latest_channel_release( Abstract_Updater::CHANNEL_RC );

		$this->assertTrue( $latest instanceof Plugin_Package );
		$this->assertEquals( '1.1.0-rc.2', $latest->get_version() );
	}

	/**
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_latest_channel_release
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_versions
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_stable_channel
	 */
	public function testGetLatestChannelReleaseStable() {
		$updater = $this->getSimpleUpdater();

		$latest = $updater->get_latest_channel_release( Abstract_Updater::CHANNEL_STABLE );

		$this->assertTrue( $latest instanceof Plugin_Package );
		$this->assertEquals( '1.0.1', $latest->get_version() );
	}

	/**
	 * @covers \Sensei_LMS_Beta\Updater\Abstract_Updater::get_latest_channel_release
	 */
	public function testGetLatestChannelReleaseBad() {
		$updater = $this->getSimpleUpdater();

		$latest = $updater->get_latest_channel_release( 'bad' );

		$this->assertFalse( $latest );
	}

	/**
	 * @return Updater_Shim
	 */
	protected function getSimpleUpdater() {
		return new Updater_Shim( $this->getSimpleSourceShim() );
	}

	/**
	 * @return Source_Shim
	 */
	protected function getSimpleSourceShim() {
		$releases = [
			'1.0.0'        => [
				'is_prerelease'        => false,
				'release_date'         => '2019-01-01',
				'download_package_url' => 'http://example.com/releases/1.0.0/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.0.0',
				'changelog_url'        => 'http://example.com/releases/1.0.0/changelog.txt',
			],
			'1.0.1'        => [
				'is_prerelease'        => false,
				'release_date'         => '2019-01-01',
				'download_package_url' => 'http://example.com/releases/1.0.1/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.0.1',
				'changelog_url'        => 'http://example.com/releases/1.0.1/changelog.txt',
			],
			'1.0.1-beta.1' => [
				'is_prerelease'        => false,
				'release_date'         => '2019-01-01',
				'download_package_url' => 'http://example.com/releases/1.0.1/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.0.1',
				'changelog_url'        => 'http://example.com/releases/1.0.1/changelog.txt',
			],
			'1.1.0-beta.1' => [
				'is_prerelease'        => true,
				'release_date'         => '2019-01-02',
				'download_package_url' => 'http://example.com/releases/1.1.0-beta.1/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.1.0-beta.1',
				'changelog_url'        => 'http://example.com/releases/1.1.0-beta.1/changelog.txt',
			],
			'1.1.0-beta.2' => [
				'is_prerelease'        => true,
				'release_date'         => '2019-01-03',
				'download_package_url' => 'http://example.com/releases/1.1.0-beta.2/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.1.0-beta.2',
				'changelog_url'        => 'http://example.com/releases/1.1.0-beta.2/changelog.txt',
			],
			'1.1.0-rc.1'   => [
				'is_prerelease'        => true,
				'release_date'         => '2019-01-03',
				'download_package_url' => 'http://example.com/releases/1.1.0-rc.1/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.1.0-rc.1',
				'changelog_url'        => 'http://example.com/releases/1.1.0-rc.1/changelog.txt',
			],
			'1.1.0-rc.2'   => [
				'is_prerelease'        => true,
				'release_date'         => '2019-01-04',
				'download_package_url' => 'http://example.com/releases/1.1.0-rc.2/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.1.0-rc.2',
				'changelog_url'        => 'http://example.com/releases/1.1.0-rc.2/changelog.txt',
			],
			'1.1.1-beta.1' => [
				'is_prerelease'        => true,
				'release_date'         => '2019-01-07',
				'download_package_url' => 'http://example.com/releases/1.1.1-beta.1/test-plugin.zip',
				'release_info_url'     => 'http://example.com/releases/1.1.1-beta.1',
				'changelog_url'        => 'http://example.com/releases/1.1.1-beta.1/changelog.txt',
			],
		];

		uksort(
			$releases,
			function ( $a, $b ) {
				return mt_rand( -10, 10 );
			}
		);

		return new Source_Shim( $releases );
	}
}
