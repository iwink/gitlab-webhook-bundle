# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Fixed
- 8.1 code compatibility.
- Unknown parameters caused an exception to be thrown on replacement.

### Changed
- Updated `doctrine/annotations` dependency to allow `^2.0`.

## [1.2.1] - 2021-05-27
### Fixed
- Support for `SystemEvent::deploykey_create`

## [1.2.0] - 2021-05-18
### Added
- Support for the following GitLab system hooks:
  - `group_create`
  - `group_destroy`
  - `group_rename`
  - `key_create`
  - `key_destroy`
  - `project_create`
  - `project_destroy`
  - `project_rename`
  - `project_transfer`
  - `project_update`
  - `repository_update`
  - `user_add_to_group`
  - `user_add_to_team`
  - `user_create`
  - `user_destroy`
  - `user_failed_login`
  - `user_remove_from_group`
  - `user_remove_from_team`
  - `user_rename`
  - `user_update_for_group`
  - `user_update_for_team`

## [1.1.0] - 2021-03-08
### Added
- Support for a secret token.

## [1.0.0] - 2021-02-19
### Added
- Support for the following GitLab webhook events:
  - `merge requests`
  - `job`
  - `pipeline`
  - `push`
  - `tag push`
  - `comment`
  - `deployment`
  - `feature flag`
  - `issue`
  - `release`
  - `wiki page`

[Unreleased]: https://github.com/iwink/gitlab-webhook-bundle/compare/v1.2.1...main
[1.2.1]: https://github.com/iwink/gitlab-webhook-bundle/compare/v1.2.0...v1.2.1
[1.2.0]: https://github.com/iwink/gitlab-webhook-bundle/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/iwink/gitlab-webhook-bundle/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/iwink/gitlab-webhook-bundle/releases/tag/v1.0.0
