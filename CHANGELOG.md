# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.0] - TBD

## [1.2.0] - 2022-12-01

### Added

- Adds `UriIntegrationTest::testGetPathNormalizesMultipleLeadingSlashesToSingleSlashToPreventXSS()`, `UriIntegrationTest::testStringRepresentationWithMultipleSlashes(array $test)`, and `RequestIntegrationTest::testGetRequestTargetInOriginFormNormalizesUriWithMultipleLeadingSlashesInPath()`.
  These validate that a path containing multiple leading slashes is (a) represented with a single slash when calling `UriInterface::getPath()`, and (b) represented without changes when calling `UriInterface::__toString()`, including when calling `RequestInterface::getRequestTarget()` (which returns the path without the URI authority by default, to comply with origin-form).
  This is done to validate mitigations for [CVE-2015-3257](https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-3257).

### Changed

- Modifies `UriIntegrationTest::testPathWithMultipleSlashes()` to only validate multiple slashes in the middle of a path.
  Multiple leading slashes are covered with the newly introduced tests.


## [1.1.1] - 2021-02-20

### Changed

- Replace deprecated assertRegExp() with assertMatchesRegularExpression()

## [1.1.0] - 2020-10-17

### Added

- Support for PHP8 and PHPUnit 8 and 9

## [1.0.0] - 2019-12-16

### Added
- Compatible with PHP5
