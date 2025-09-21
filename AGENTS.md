# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- inertiajs/inertia-laravel (version 2.0.6)
- laravel/fortify (version 1.30.0)
- laravel/framework (version 12.30.1)
- laravel/prompts (version 0.3.6)
- laravel/wayfinder (version 0.1.12)
- laravel/pint (version 1.25.1)
- laravel/sail (version 1.45.0)
- pestphp/pest (version 4.1.0)
- phpunit/phpunit (version 12.3.8)
- @inertiajs/vue3 (version 2.1.7)
- tailwindcss (version 4.1.13)
- vue (version 3.5.21)
- @laravel/vite-plugin-wayfinder (version 0.1.3)
- eslint (version 9.36.0)
- prettier (version 3.6.2)

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure - don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## PHP 8.4

- PHP 8.4 has new array functions that will make code simpler whenever we don't use Laravel's collections.
  - `array_find(array $array, callable $callback): mixed` - Find first matching element
  - `array_find_key(array $array, callable $callback): int|string|null` - Find first matching key
  - `array_any(array $array, callable $callback): bool` - Check if any element satisfies a callback function
  - `array_all(array $array, callable $callback): bool` - Check if all elements satisfy a callback function

### Cleaner Chaining on New Instances

- No extra parentheses are needed when chaining on new object instances:

```php
// Before PHP 8.4
$response = (new JsonResponse(['data' => $data]))->setStatusCode(201);

// After PHP 8.4
$response = new JsonResponse(['data' => $data])->setStatusCode(201);
```

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database

- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation

- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues

- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization

- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration

- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] <name>` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Laravel 12

- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

### Laravel 12 Structure

- No middleware files in `app/Http/Middleware/`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- **No app\Console\Kernel.php** - use `bootstrap/app.php` or `routes/console.php` for console configuration.
- **Commands auto-register** - files in `app/Console/Commands/` are automatically available and do not require manual registration.
  @endif

### Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 11 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

## Inertia Core

- Inertia.js components should be placed in the `resources/js/Pages` directory unless specified differently in the JS bundler (vite.config.js).
- Use `Inertia::render()` for server-side routing instead of traditional Blade views.

```php
// routes/web.php example
Route::get('/users', function () {
    return Inertia::render('Users/Index', [
        'users' => User::all()
    ]);
});
```

## Inertia v2

- Make use of all Inertia features from v1 & v2. Check the documentation before making any changes to ensure we are taking the correct approach.

### Inertia v2 New Features

- Polling
- Prefetching
- Deferred props
- Infinite scrolling using merging props and `WhenVisible`
- Lazy loading data on scroll

### Deferred Props & Empty States

- When using deferred props on the frontend, you should add a nice empty state with pulsing / animated skeleton.

### Inertia Form General Guidance

@if ($assist->inertia()->hasFormComponent())

- The recommended way to build forms when using Inertia is with the `<Form>` component - a useful example is below.
- Forms can also be built using the `useForm` helper for more programmatic control, or to follow existing conventions.
- `resetOnError`, `resetOnSuccess`, and `setDefaultsOnSuccess` are available on the `<Form>` component.

## Inertia + Vue

- Vue components must have a single root element.
- Use `router.visit()` or `<Link>` for navigation instead of traditional links.

```vue
import { Link } from '@inertiajs/vue3';
<Link href="/">Home</Link>
```

## Inertia + Vue Forms

```vue
<Form
  action="/users"
  method="post"
  #default="{
    errors,
    hasErrors,
    processing,
    progress,
    wasSuccessful,
    recentlySuccessful,
    setError,
    clearErrors,
    resetAndClearErrors,
    defaults,
    isDirty,
    reset,
    submit,
  }"
>
    <input type="text" name="name" />

    <div v-if="errors.name">
        {{ errors.name }}
    </div>

    <button type="submit" :disabled="processing">
        {{ processing ? 'Creating...' : 'Create User' }}
    </button>

    <div v-if="wasSuccessful">User created successfully!</div>
</Form>
```

## Tailwind 4

- Always use Tailwind CSS v4 - do not use the deprecated utilities.
- `corePlugins` is not supported in Tailwind v4.
- In Tailwind v4, you import Tailwind using a regular CSS `@import` statement, not using the `@tailwind` directives used in v3:
  @verbatim
  <code-snippet name="Tailwind v4 Import Tailwind Diff" lang="diff">
  - @tailwind base;
  - @tailwind components;
  - @tailwind utilities;
  * @import "tailwindcss";
    </code-snippet>
    @endverbatim

### Replaced Utilities

- Tailwind v4 removed deprecated utilities. Do not use the deprecated option - use the replacement.
- Opacity values are still numeric.

| Deprecated | Replacement |
|------------+--------------|
| bg-opacity-_ | bg-black/_ |
| text-opacity-_ | text-black/_ |
| border-opacity-_ | border-black/_ |
| divide-opacity-_ | divide-black/_ |
| ring-opacity-_ | ring-black/_ |
| placeholder-opacity-_ | placeholder-black/_ |
| flex-shrink-_ | shrink-_ |
| flex-grow-_ | grow-_ |
| overflow-ellipsis | text-ellipsis |
| decoration-slice | box-decoration-slice |
| decoration-clone | box-decoration-clone |

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.

# Nuxt UI

> A comprehensive, Nuxt-integrated UI library providing a rich set of fully-styled, accessible and highly customizable components for building modern web applications.

## Getting Started

- [Introduction](https://ui.nuxt.com/raw/getting-started.md): Nuxt UI harnesses the combined strengths of Reka UI, Tailwind CSS, and Tailwind Variants to offer developers an unparalleled set of tools for creating sophisticated, accessible, and highly performant user interfaces.
- [Installation](https://ui.nuxt.com/raw/getting-started/installation/nuxt.md): Learn how to install and configure Nuxt UI in your Nuxt application.
- [Installation](https://ui.nuxt.com/raw/getting-started/installation/vue.md): Learn how to install and configure Nuxt UI in your Vue application.
- [Installation](https://ui.nuxt.com/raw/getting-started/installation/pro/nuxt.md): Learn how to install and configure Nuxt UI Pro in your Nuxt application.
- [Installation](https://ui.nuxt.com/raw/getting-started/installation/pro/vue.md): Learn how to install and configure Nuxt UI Pro in your Vue application.
- [Migration](https://ui.nuxt.com/raw/getting-started/migration.md): A comprehensive guide to migrate your application from Nuxt UI v2 to Nuxt UI v3.
- [License](https://ui.nuxt.com/raw/getting-started/license.md): Nuxt UI Pro is free in development, but you need a license to build your app in production.
- [Theme](https://ui.nuxt.com/raw/getting-started/theme.md): Learn how to customize Nuxt UI components using Tailwind CSS v4, CSS variables and the Tailwind Variants API for powerful and flexible theming.
- [Icons](https://ui.nuxt.com/raw/getting-started/icons/nuxt.md): Nuxt UI integrates with Nuxt Icon to access over 200,000+ icons from Iconify.
- [Icons](https://ui.nuxt.com/raw/getting-started/icons/vue.md): Nuxt UI integrates with Iconify to access over 200,000+ icons.
- [Fonts](https://ui.nuxt.com/raw/getting-started/fonts.md): Nuxt UI integrates with Nuxt Fonts to provide plug-and-play font optimization.
- [Color Mode](https://ui.nuxt.com/raw/getting-started/color-mode/nuxt.md): Nuxt UI integrates with Nuxt Color Mode to allow for easy switching between light and dark themes.
- [Color Mode](https://ui.nuxt.com/raw/getting-started/color-mode/vue.md): Nuxt UI integrates with VueUse to allow for easy switching between light and dark themes.
- [Internationalization (i18n)](https://ui.nuxt.com/raw/getting-started/i18n/nuxt.md): Learn how to internationalize your Nuxt app with multi-directional support (LTR/RTL).
- [Internationalization (i18n)](https://ui.nuxt.com/raw/getting-started/i18n/vue.md): Learn how to internationalize your Vue app with multi-directional support (LTR/RTL).
- [Content](https://ui.nuxt.com/raw/getting-started/content.md): Nuxt UI Pro enhances Nuxt Content with beautiful components and styling.
- [Typography](https://ui.nuxt.com/raw/getting-started/typography.md): Nuxt UI Pro provides beautiful typography components and utilities to style your content.
- [Contribution Guide](https://ui.nuxt.com/raw/getting-started/contribution.md): A comprehensive guide on contributing to Nuxt UI, including project structure, development workflow, and best practices.

## Components

- [App](https://ui.nuxt.com/raw/components/app.md): Wraps your app to provide global configurations and more.
- [Accordion](https://ui.nuxt.com/raw/components/accordion.md): A stacked set of collapsible panels.
- [Alert](https://ui.nuxt.com/raw/components/alert.md): A callout to draw user's attention.
- [AuthForm](https://ui.nuxt.com/raw/components/auth-form.md): A customizable Form to create login, register or password reset forms.
- [Avatar](https://ui.nuxt.com/raw/components/avatar.md): An img element with fallback and Nuxt Image support.
- [AvatarGroup](https://ui.nuxt.com/raw/components/avatar-group.md): Stack multiple avatars in a group.
- [Badge](https://ui.nuxt.com/raw/components/badge.md): A short text to represent a status or a category.
- [Banner](https://ui.nuxt.com/raw/components/banner.md): Display a banner at the top of your website to inform users about important information.
- [BlogPost](https://ui.nuxt.com/raw/components/blog-post.md): A customizable article to display in a blog page.
- [BlogPosts](https://ui.nuxt.com/raw/components/blog-posts.md): Display a list of blog posts in a responsive grid layout.
- [Breadcrumb](https://ui.nuxt.com/raw/components/breadcrumb.md): A hierarchy of links to navigate through a website.
- [Button](https://ui.nuxt.com/raw/components/button.md): A button element that can act as a link or trigger an action.
- [ButtonGroup](https://ui.nuxt.com/raw/components/button-group.md): Group multiple button-like elements together.
- [Calendar](https://ui.nuxt.com/raw/components/calendar.md): A calendar component for selecting single dates, multiple dates or date ranges.
- [Card](https://ui.nuxt.com/raw/components/card.md): Display content in a card with a header, body and footer.
- [Carousel](https://ui.nuxt.com/raw/components/carousel.md): A carousel with motion and swipe built using Embla.
- [ChangelogVersion](https://ui.nuxt.com/raw/components/changelog-version.md): A customizable article to display in a changelog.
- [ChangelogVersions](https://ui.nuxt.com/raw/components/changelog-versions.md): Display a list of changelog versions in a timeline.
- [ChatMessage](https://ui.nuxt.com/raw/components/chat-message.md): Display a chat message with icon, avatar, and actions.
- [ChatMessages](https://ui.nuxt.com/raw/components/chat-messages.md): Display a list of chat messages, designed to work seamlessly with Vercel AI SDK.
- [ChatPalette](https://ui.nuxt.com/raw/components/chat-palette.md): A chat palette to create a chatbot interface inside an overlay.
- [ChatPrompt](https://ui.nuxt.com/raw/components/chat-prompt.md): An enhanced Textarea for submitting prompts in AI chat interfaces.
- [ChatPromptSubmit](https://ui.nuxt.com/raw/components/chat-prompt-submit.md): A Button for submitting chat prompts with automatic status handling.
- [Checkbox](https://ui.nuxt.com/raw/components/checkbox.md): An input element to toggle between checked and unchecked states.
- [CheckboxGroup](https://ui.nuxt.com/raw/components/checkbox-group.md): A set of checklist buttons to select multiple option from a list.
- [Chip](https://ui.nuxt.com/raw/components/chip.md): An indicator of a numeric value or a state.
- [Collapsible](https://ui.nuxt.com/raw/components/collapsible.md): A collapsible element to toggle visibility of its content.
- [ColorModeAvatar](https://ui.nuxt.com/raw/components/color-mode-avatar.md): An Avatar with a different source for light and dark mode.
- [ColorModeButton](https://ui.nuxt.com/raw/components/color-mode-button.md): A Button to switch between light and dark mode.
- [ColorModeImage](https://ui.nuxt.com/raw/components/color-mode-image.md): An image element with a different source for light and dark mode.
- [ColorModeSelect](https://ui.nuxt.com/raw/components/color-mode-select.md): A Select to switch between system, dark & light mode.
- [ColorModeSwitch](https://ui.nuxt.com/raw/components/color-mode-switch.md): A switch to toggle between light and dark mode.
- [ColorPicker](https://ui.nuxt.com/raw/components/color-picker.md): A component to select a color.
- [CommandPalette](https://ui.nuxt.com/raw/components/command-palette.md): A command palette with full-text search powered by Fuse.js for efficient fuzzy matching.
- [Container](https://ui.nuxt.com/raw/components/container.md): A container lets you center and constrain the width of your content.
- [ContentNavigation](https://ui.nuxt.com/raw/components/content-navigation.md): An accordion-style navigation component for organizing page links.
- [ContentSearch](https://ui.nuxt.com/raw/components/content-search.md): A ready to use CommandPalette to add to your documentation.
- [ContentSearchButton](https://ui.nuxt.com/raw/components/content-search-button.md): A pre-styled Button to open the ContentSearch modal.
- [ContentSurround](https://ui.nuxt.com/raw/components/content-surround.md): A pair of prev and next links to navigate between pages.
- [ContentToc](https://ui.nuxt.com/raw/components/content-toc.md): A sticky Table of Contents with automatic active anchor link highlighting.
- [ContextMenu](https://ui.nuxt.com/raw/components/context-menu.md): A menu to display actions when right-clicking on an element.
- [DashboardGroup](https://ui.nuxt.com/raw/components/dashboard-group.md): A fixed layout component that provides context for dashboard components with sidebar state management and persistence.
- [DashboardNavbar](https://ui.nuxt.com/raw/components/dashboard-navbar.md): A responsive navbar to display in a dashboard.
- [DashboardPanel](https://ui.nuxt.com/raw/components/dashboard-panel.md): A resizable panel to display in a dashboard.
- [DashboardResizeHandle](https://ui.nuxt.com/raw/components/dashboard-resize-handle.md): A handle to resize a sidebar or panel.
- [DashboardSearch](https://ui.nuxt.com/raw/components/dashboard-search.md): A ready to use CommandPalette to add to your dashboard.
- [DashboardSearchButton](https://ui.nuxt.com/raw/components/dashboard-search-button.md): A pre-styled Button to open the DashboardSearch modal.
- [DashboardSidebar](https://ui.nuxt.com/raw/components/dashboard-sidebar.md): A resizable and collapsible sidebar to display in a dashboard.
- [DashboardSidebarCollapse](https://ui.nuxt.com/raw/components/dashboard-sidebar-collapse.md): A Button to collapse the sidebar on desktop.
- [DashboardSidebarToggle](https://ui.nuxt.com/raw/components/dashboard-sidebar-toggle.md): A Button to toggle the sidebar on mobile.
- [DashboardToolbar](https://ui.nuxt.com/raw/components/dashboard-toolbar.md): A toolbar to display under the navbar in a dashboard.
- [Drawer](https://ui.nuxt.com/raw/components/drawer.md): A drawer that smoothly slides in & out of the screen.
- [DropdownMenu](https://ui.nuxt.com/raw/components/dropdown-menu.md): A menu to display actions when clicking on an element.
- [Error](https://ui.nuxt.com/raw/components/error.md): A pre-built error component with NuxtError support.
- [FileUpload](https://ui.nuxt.com/raw/components/file-upload.md): An input element to upload files.
- [Footer](https://ui.nuxt.com/raw/components/footer.md): A responsive footer component.
- [FooterColumns](https://ui.nuxt.com/raw/components/footer-columns.md): A list of links as columns to display in your Footer.
- [Form](https://ui.nuxt.com/raw/components/form.md): A form component with built-in validation and submission handling.
- [FormField](https://ui.nuxt.com/raw/components/form-field.md): A wrapper for form elements that provides validation and error handling.
- [Header](https://ui.nuxt.com/raw/components/header.md): A responsive header component.
- [Icon](https://ui.nuxt.com/raw/components/icon.md): A component to display any icon from Iconify.
- [Input](https://ui.nuxt.com/raw/components/input.md): An input element to enter text.
- [InputMenu](https://ui.nuxt.com/raw/components/input-menu.md): An autocomplete input with real-time suggestions.
- [InputNumber](https://ui.nuxt.com/raw/components/input-number.md): An input for numerical values with a customizable range.
- [InputTags](https://ui.nuxt.com/raw/components/input-tags.md): An input element that displays interactive tags.
- [Kbd](https://ui.nuxt.com/raw/components/kbd.md): A kbd element to display a keyboard key.
- [Link](https://ui.nuxt.com/raw/components/link.md): A wrapper around <NuxtLink> with extra props.
- [LocaleSelect](https://ui.nuxt.com/raw/components/locale-select.md): A Select to switch between locales.
- [Main](https://ui.nuxt.com/raw/components/main.md): A main element that fills the available viewport height.
- [Modal](https://ui.nuxt.com/raw/components/modal.md): A dialog window that can be used to display a message or request user input.
- [NavigationMenu](https://ui.nuxt.com/raw/components/navigation-menu.md): A list of links that can be displayed horizontally or vertically.
- [Page](https://ui.nuxt.com/raw/components/page.md): A grid layout for your pages with left and right columns.
- [PageAccordion](https://ui.nuxt.com/raw/components/page-accordion.md): A pre-styled Accordion to display in your pages.
- [PageAnchors](https://ui.nuxt.com/raw/components/page-anchors.md): A list of anchors to be displayed in the page.
- [PageAside](https://ui.nuxt.com/raw/components/page-aside.md): A sticky aside to display your page navigation.
- [PageBody](https://ui.nuxt.com/raw/components/page-body.md): The main content of your page.
- [PageCard](https://ui.nuxt.com/raw/components/page-card.md): A pre-styled card component that displays a title, description and optional link.
- [PageColumns](https://ui.nuxt.com/raw/components/page-columns.md): A responsive multi-column layout system for organizing content side-by-side.
- [PageCTA](https://ui.nuxt.com/raw/components/page-cta.md): A call to action section to display in your pages.
- [PageFeature](https://ui.nuxt.com/raw/components/page-feature.md): A component to showcase key features of your application.
- [PageGrid](https://ui.nuxt.com/raw/components/page-grid.md): A responsive grid system for displaying content in a flexible layout.
- [PageHeader](https://ui.nuxt.com/raw/components/page-header.md): A responsive header for your pages.
- [PageHero](https://ui.nuxt.com/raw/components/page-hero.md): A responsive hero for your pages.
- [PageLinks](https://ui.nuxt.com/raw/components/page-links.md): A list of links to be displayed in the page.
- [PageList](https://ui.nuxt.com/raw/components/page-list.md): A vertical list layout for displaying content in a stacked format.
- [PageLogos](https://ui.nuxt.com/raw/components/page-logos.md): A list of logos or images to display on your pages.
- [PageMarquee](https://ui.nuxt.com/raw/components/page-marquee.md): A component to create infinite scrolling content.
- [PageSection](https://ui.nuxt.com/raw/components/page-section.md): A responsive section for your pages.
- [Pagination](https://ui.nuxt.com/raw/components/pagination.md): A list of buttons or links to navigate through pages.
- [PinInput](https://ui.nuxt.com/raw/components/pin-input.md): An input element to enter a pin.
- [Popover](https://ui.nuxt.com/raw/components/popover.md): A non-modal dialog that floats around a trigger element.
- [PricingPlan](https://ui.nuxt.com/raw/components/pricing-plan.md): A customizable pricing plan to display in a pricing page.
- [PricingPlans](https://ui.nuxt.com/raw/components/pricing-plans.md): Display a list of pricing plans in a responsive grid layout.
- [PricingTable](https://ui.nuxt.com/raw/components/pricing-table.md): A responsive pricing table component that displays tiered pricing plans with feature comparisons.
- [Progress](https://ui.nuxt.com/raw/components/progress.md): An indicator showing the progress of a task.
- [RadioGroup](https://ui.nuxt.com/raw/components/radio-group.md): A set of radio buttons to select a single option from a list.
- [Select](https://ui.nuxt.com/raw/components/select.md): A select element to choose from a list of options.
- [SelectMenu](https://ui.nuxt.com/raw/components/select-menu.md): An advanced searchable select element.
- [Separator](https://ui.nuxt.com/raw/components/separator.md): Separates content horizontally or vertically.
- [Skeleton](https://ui.nuxt.com/raw/components/skeleton.md): A placeholder to show while content is loading.
- [Slideover](https://ui.nuxt.com/raw/components/slideover.md): A dialog that slides in from any side of the screen.
- [Slider](https://ui.nuxt.com/raw/components/slider.md): An input to select a numeric value within a range.
- [Stepper](https://ui.nuxt.com/raw/components/stepper.md): A set of steps that are used to indicate progress through a multi-step process.
- [Switch](https://ui.nuxt.com/raw/components/switch.md): A control that toggles between two states.
- [Table](https://ui.nuxt.com/raw/components/table.md): A responsive table element to display data in rows and columns.
- [Tabs](https://ui.nuxt.com/raw/components/tabs.md): A set of tab panels that are displayed one at a time.
- [Textarea](https://ui.nuxt.com/raw/components/textarea.md): A textarea element to input multi-line text.
- [Timeline](https://ui.nuxt.com/raw/components/timeline.md): A component that displays a sequence of events with dates, titles, icons or avatars.
- [Toast](https://ui.nuxt.com/raw/components/toast.md): A succinct message to provide information or feedback to the user.
- [Tooltip](https://ui.nuxt.com/raw/components/tooltip.md): A popup that reveals information when hovering over an element.
- [Tree](https://ui.nuxt.com/raw/components/tree.md): A tree view component to display and interact with hierarchical data structures.
- [User](https://ui.nuxt.com/raw/components/user.md): Display user information with name, description and avatar.

## Composables

- [defineShortcuts](https://ui.nuxt.com/raw/composables/define-shortcuts.md): A composable to define keyboard shortcuts in your app.
- [useFormField](https://ui.nuxt.com/raw/composables/use-form-field.md): A composable to integrate custom inputs with the Form component
- [useOverlay](https://ui.nuxt.com/raw/composables/use-overlay.md): A composable to programmatically control overlays.
- [useToast](https://ui.nuxt.com/raw/composables/use-toast.md): A composable to display toast notifications in your app.

## Documentation Sets

- [Nuxt UI Full Documentation](https://ui.nuxt.com/llms-full.txt): This is the full documentation for Nuxt UI. It includes all the Markdown files written with the MDC syntax.

## Notes

- The documentation excludes Nuxt UI v2 content.
- The content is automatically generated from the same source as the official documentation.
