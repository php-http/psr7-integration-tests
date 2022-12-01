# Change Log

## Added

- Adds `UriIntegrationTest::testGetPathNormalizesMultipleLeadingSlashesToSingleSlashToPreventXSS()`, `UriIntegrationTest::testStringRepresentationWithMultipleSlashes(array $test)`, and `RequestIntegrationTest::testGetRequestTargetInOriginFormNormalizesUriWithMultipleLeadingSlashesInPath()`.
  These validate that a path containing multiple leading slashes is (a) represented with a single slash when calling `UriInterface::getPath()`, and (b) represented without changes when calling `UriInterface::__toString()`, including when calling `RequestInterface::getRequestTarget()` (which returns the path without the URI authority by default, to comply with origin-form).
  This is done to validate mitigations for [CVE-2015-3257](https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-3257).

## Changed

- Modifies `UriIntegrationTest::testPathWithMultipleSlashes()` to only validate multiple slashes in the middle of a path.
  Multiple leading slashes are covered with the newly introduced tests.
