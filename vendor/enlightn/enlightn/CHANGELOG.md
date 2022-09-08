# Release Notes

## [Unreleased](https://github.com/enlightn/enlightn/compare/v1.8.0...master)

## [v1.8.0 (2021-02-01)](https://github.com/enlightn/enlightn/compare/v1.7.1...v1.8.0)

### Added
- Make improvements to static analysis ([#26](https://github.com/enlightn/enlightn/pull/26))

## [v1.7.1 (2021-01-29)](https://github.com/enlightn/enlightn/compare/v1.7...v1.7.1)

### Fixed
- Fix percentage calculations ([#22](https://github.com/enlightn/enlightn/pull/22))

### Added
- Faster tests by adding paratest and remove un-needed services ([#20](https://github.com/enlightn/enlightn/pull/20))

## [v1.7 (2021-01-27)](https://github.com/enlightn/enlightn/compare/v1.6...v1.7)

### Added
- Add analyzer to detect syntax errors ([#19](https://github.com/enlightn/enlightn/pull/19))
- Support custom categories ([#18](https://github.com/enlightn/enlightn/pull/18))

## [v1.6 (2021-01-26)](https://github.com/enlightn/enlightn/compare/v1.5...v1.6)

### Fixed
- Fix crash when there is a syntax error in one of the app files ([#17](https://github.com/enlightn/enlightn/pull/17))

## [v1.5 (2021-01-26)](https://github.com/enlightn/enlightn/compare/v1.4...v1.5)

### Added
- Add CC0 and Unlicense to list of whitelisted licenses ([#15](https://github.com/enlightn/enlightn/pull/15))
- Add option to show all files in the Enlightn command ([#16](https://github.com/enlightn/enlightn/pull/16))

## [v1.4 (2021-01-22)](https://github.com/enlightn/enlightn/compare/v1.3...v1.4)

### Added
- Add ability to exclude analyzers from reporting for CI/CD ([#12](https://github.com/enlightn/enlightn/pull/12))

### Fixed
- Add function check for opcache_get_configuration so it gracefully fails ([#10](https://github.com/enlightn/enlightn/pull/10))
- Fix logo for white terminals ([#11](https://github.com/enlightn/enlightn/pull/11))

## [v1.3 (2021-01-22)](https://github.com/enlightn/enlightn/compare/v1.2...v1.3)

### Added
- Add trinary maybe logic for PHPStan ([#9](https://github.com/enlightn/enlightn/pull/9))

## [v1.2 (2021-01-21)](https://github.com/enlightn/enlightn/compare/v1.1...v1.2)

### Changed
- Improved detection of HTTPS only apps ([#8](https://github.com/enlightn/enlightn/pull/8))

## [v1.1 (2021-01-20)](https://github.com/enlightn/enlightn/compare/v1.0...v1.1)

### Added
- Failing mode for CI ([#3](https://github.com/enlightn/enlightn/pull/3))

### Changed
- Skip XSS analyzer in local ([#6](https://github.com/enlightn/enlightn/pull/6))
- Replace SensioLabs security checker with Enlightn's own security checker ([#5](https://github.com/enlightn/enlightn/pull/5))

### Fixed
- Fix analyzer percentage computation ([#7](https://github.com/enlightn/enlightn/pull/7))
