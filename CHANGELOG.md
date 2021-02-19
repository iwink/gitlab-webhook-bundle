# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- The `comment`, `deployment` `feature flag`, `issue`, `release` & `wiki page` events [#172063](https://intranet.iwink.nl/task_task?id=172063).

### Changed
- The way events are resolved from requests has changed [#172063](https://intranet.iwink.nl/task_task?id=172063).

## [0.3.1] - 2020-12-21
### Fixed
- Unit tests are easier to read [#172575](https://intranet.iwink.nl/task_task?id=172575).

## [0.3.0] - 2020-12-21
### Added
- `WebhookEvent` instances can now be accessed as arrays [#172575](https://intranet.iwink.nl/task_task?id=172575).

## [0.2.0] - 2020-12-21
### Added
- Support to register `merge request` events in a controller [#172575](https://intranet.iwink.nl/task_task?id=172575).

## [0.1.0] - 2020-11-11
### Added
- Support to register `job`, `pipeline`, `push` & `tag push` events in a controller [#167530](https://intranet.iwink.nl/task_task?id=167530).

[Unreleased]: https://gitlab.services.kirra.nl/kirra/gitlab-webhook-bundle/compare/v0.3.1...develop
[0.3.1]: https://gitlab.services.kirra.nl/kirra/gitlab-webhook-bundle/compare/v0.3.0...v0.3.1
[0.3.0]: https://gitlab.services.kirra.nl/kirra/gitlab-webhook-bundle/compare/v0.2.0...v0.3.0
[0.2.0]: https://gitlab.services.kirra.nl/kirra/gitlab-webhook-bundle/compare/v0.1.0...v0.2.0
[0.1.0]: https://gitlab.services.kirra.nl/kirra/gitlab-webhook-bundle/tree/v0.1.0
