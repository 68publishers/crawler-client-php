# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

## 1.2.1 - 2024-10-14
### Added
- Added support v `symfony/yaml` v7.
- Added PHP 8.3 between tested versions.

## 1.2.0 - 2023-07-11
### Added
- Added method `ScenarioSchedulersController::activateScenarioScheduler()`.
- Added method `ScenarioSchedulersController::deactivateScenarioScheduler()`.
- Added property `bool $active` and mapping for value object `ScenarioSchedulerListingItem`, request body `ScenarioSchedulerRequestBody` and response body `ScenarioSchedulerResponseBody`.

### Changed
- Updated README.

## 1.1.1 - 2023-06-21
### Added
- Added method `CrawlerClientInterface::getSerializer()`.

## 1.1.0 - 2023-06-20
### Added

- Added the field `finishedAt` for the value object `ScenarioListingItem` (`GET /api/scenarios`).
- Added the field `finishedAt` for the response body `ScenarioResponseBody` (`GET /api/scenarios/:scenarioId`).
- Added method `ScenariosController::abortScenario()` (`PUT /api/scenarios/:scenarioId/abort`).
- Added tests.

## 1.0.0 - 2023-06-09
### Added

- Initial release.
