# BrewHub
BrewHub is a CakePHP 5 application for managing an e-commerce workflow around coffee products, orders, users, and content blocks. It includes a customer-facing shop and an admin experience for managing products, inventory, orders, and users. This README provides an overview of the stack, how to get started, and a map of the repository to help future developers navigate the codebase.
## Tech stack
- Backend: PHP 8.1+, CakePHP 5.2.x
- Authentication: cakephp/authentication 3.x
- Payments: stripe/stripe-php 14.x
- Content blocks: ugie-cake/cakephp-content-blocks 1.x
- Device detection: mobiledetect/mobiledetectlib 4.x
- PDF generation: dompdf/dompdf 2.0
- Password strength: bjeavons/zxcvbn-php 1.x
- Database: Relational DB via CakePHP ORM and PhpMyAdmin (Migrations and Seeds included)
- Frontend assets: Vanilla JS + third-party vendor (Bootstrap)
- Testing: PHPUnit 10/11/12 (project set for flexible versions)
- Coding standards: PHP_CodeSniffer (CakePHP rules)
- Package management: Composer (PHP)
## Quick start
1. Requirements
    - PHP 8.1+
    - Composer
    - A database (MySQL/MariaDB with PhpMyAdmin)
2. Install dependencies
    - PHP: composer install
3. Configuration
    - Update config/app_local.php with your environment-specific settings, either one already set up with your team or a new one.
4. Database
    - Import Database.sql Schema found in config/schema into PhpMyAdmin. Bake all models, controllers, and templates, and then rollback commit.
    - Seed data: bin/cake migrations seed  for content blocks.
5. Serve
    - Development server: bin/cake server
    - Or configure your web server to point DocumentRoot to webroot/
## Repository map
Top-level
- README.md: This file
- composer.json / composer.lock: PHP dependencies
- phpunit.xml.dist: PHPUnit configuration
- phpstan.neon: PHPStan configuration
- psalm.xml: Psalm configuration
- phpcs.xml: PHP_CodeSniffer ruleset
- .editorconfig, .gitattributes, .gitignore: Repo and editor settings
- index.php: Project entry point redirector
- .github: CI/CD, issue templates, actions
  Application runtime and public
- webroot/
    - index.php: Front controller (public entry)
    - assets/, css/, js/, img/: Static assets
    - vendor/: Third-party frontend libraries (Bootstrap)
    - .htaccess: URL rewriting for Apache
      CakePHP application
- src/
    - Application.php: Bootstrap of the application (middleware stack, plugins, container services)
    - Controller/: MVC controllers (HTTP actions)
    - Model/
        - Table/: ORM table classes (data access, associations, finders)
        - Entity/: ORM entity classes (domain records, accessors/mutators)
        - Behavior/: Reusable ORM behaviors
    - Middleware/: HTTP middleware
    - Mailer/: Email transports and mailers
    - Console/: CLI commands for tasks and maintenance
    - View/: View classes and helpers
- templates/
    - Layouts and templates for controllers (Products, Orders, Users, Shop, etc.)
    - element/, cell/: Reusable view fragments and cells
    - email/: Email templates (HTML/text)
    - Pages/: Static and dashboard pages
    - Error/: Error pages
- config/
    - app.php: Base app configuration
    - app_local.php (do not commit) / app_local.example.php: Environment overrides
    - .env.example: Environment variable template
    - bootstrap.php: Bootstraps configuration, plugins, cache, logging
    - plugins.php: Plugin loading
    - routes.php: Application routes
    - paths.php: Path constants for CakePHP
    - Migrations/: Database migrations (phinx-based via Cake migrations plugin)
    - Seeds/: Database seeders (initial content, fixtures)
    - schema/: SQL or schema-related files
- plugins/
    - Optional CakePHP plugins (local) placed here
      Development, cache, logs
- logs/: Application logs
- tmp/: Cache, sessions, and other runtime files (not for committing)
- .phpunit.cache/: PHPUnit caching for faster runs
  Tooling
- bin/: CakePHP console launcher and other CLI entry scripts
- phpcs.xml, phpstan.neon, psalm.xml: QA tools configuration
  Tests
- tests/: PHPUnit test suites
    - TestCase/ for unit/integration tests
    - Fixtures/ for test data
    - Application and HTTP tests as applicable
## Common flows
- Routing: Defined in config/routes.php; controllers in src/Controller handle requests.
- Data: ORM Table classes define associations, validation, and custom finders; Entities hold domain logic like accessors/mutators.
- Views: templates/ControllerName/*action_name*.php with layout in templates/layout.
- Auth: Look for Authentication setup in Application.php, middleware stack, and relevant Controller components/identifiers.
- Emails: src/Mailer with templates under templates/email.
## Environment and configuration
- Use config/app_local.php to manage secrets and environment-specific settings.
- Enable/disable debug in config/app_local.php (DebugKit is typically available in development).
## Coding standards and quality
- Follow CakePHP conventions (PSR-12 compatible).
- Run vendor/bin/phpcs to enforce standards; vendor/bin/phpcbf can auto-fix.
- Use vendor/bin/phpstan and vendor/bin/psalm for static analysis.
- Keep tests updated; run vendor/bin/phpunit locally and in CI.
## Frontend assets
- Primary static assets live in webroot/.
- Third-party libraries are under webroot/vendor/.
- If adding new packages via npm, document the build or copy process to webroot to keep deploys deterministic.
## Deployment notes
- Point your web server to webroot/ as the DocumentRoot.
- Ensure tmp/ and logs/ are writable by the web server user.
- Run migrations on deploy; seed only when appropriate.
- Set proper APP_ENV/APP_DEBUG and security keys via .env or app_local.php.
## Troubleshooting
- 404/rewrites: Check webroot/.htaccess and server rewrite rules.
- Sessions/cache: Verify tmp/ permissions and cache configuration in config/bootstrap.php.
- DB connection: Validate DSN in .env or app_local.php.
- Assets not loading: Ensure DocumentRoot is webroot/ and correct base URL in configuration.
## Contributing
- Create feature branches, write tests, and run QA tools before opening a PR.
- Keep migrations atomic and reversible; include Seeds if initial data is required for new features.
- Update this README and templates when adding major features or modules.
## Maintainers
### Team (220):
Deakin
Inka
Jagannath
Ken
Sam
## Last Updated
October 22, 2025
