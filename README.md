# AutomaticActionUX

This plugin gives the Automatic Action interface a complete makeover to make it more user friendly. Particularly useful for visual learners and non-English speaking users, this plugin adds a quick glance of Actions on the board avoiding careless drag-happy mistakes.

#### _Plugin for [Kanboard](https://github.com/fguillot/kanboard "Kanboard - Kanban Project Management Software")_


Features
-------------

- Simplified and revamped the Automatic Actions page in `Project Settings`
- Added icons for better user experience
- Display Action IDs
- Converted existing core layout to a better table
- Display total actions for the project
- Identify difference between user-triggered and system-triggered actions
- Add action data in the project dropdown menu
  - Add total actions (with user/system splits) relevant to the project
  - Display totals as a separate mini bar
  - Show totals even if zero
  - Do not show on Project Automatic Actions Listing page


Screenshots
----------

**Automatic Actions Listing Page**  

![Automatic Actions Listing Page](../master/screenshot.png "Automatic Actions Listing Page")

**Project Dropdown Menu**  

![Project Dropdown Menu](../master/screenshot-dropdown.png "Project Dropdown Menu")


Usage
-------------

Go to `Project` &#10562; `Configure Project` &#10562; **Automatic Actions**


Compatibility
-------------

- Requires [Kanboard](https://github.com/fguillot/kanboard "Kanboard - Kanban Project Management Software") ≥`1.2.20`

#### Other Plugins & Action Plugins
- Compatible with [KanboardEmailHistory](https://github.com/aljawaid/KanboardEmailHistory), [KanboardCSS](https://github.com/aljawaid/KanboardCSS)
#### Core Files & Templates
- `01` Template override
- _No database changes_

Changelog
---------

Read the full [**Changelog**](../master/changelog.md "See changes")


Installation
------------

- **Install via [Kanboard](https://github.com/fguillot/kanboard "Kanboard - Kanban Project Management Software") Plugin Directory**
  - _Go to_ Kanboard: `Settings` -> `Plugins` -> `Plugin Directory`
  - _or with [PluginManager](https://github.com/aljawaid/PluginManager) installed:_
    - Kanboard: `Settings` &#10562; `Plugins` &#10562; `Plugin Directory`
    
**_or_**

- **Install via [Releases](../master/Releases/ "A copy of each release is saved in the folder") folder**
 - A copy of each release is saved in the `/Releases` folder of the repository
 - Simply extract the `.zip` file into the `/plugins` directory

**_or_**

- **Install via [GitHub](https://github.com/aljawaid "Find the correct plugin from the list of repositories")**
- Download the `.zip` file and decompress everything under the directory `/plugins`
 - The folder inside the `.zip` must not contain any branch names and must be exact case (matching the plugin name)

_Note: The `/plugins` folder is case-sensitive._

**_or_**

- **Install using Git CLI**
- `git clone` (_or ftp upload_) and extract the `.zip` file into this folder: `.\plugins\` (must be exact case)


Translations
------------

- English (UK), German (Standard, Formal), German (Standard, Informal)
- _Contributors welcome_
- _Starter template available_


Authors & Contributors
----------------------

- [@aljawaid](https://github.com/aljawaid) - Author
- [Craig Crosby](https://github.com/creecros) - Contributor
- [Stehle](https://github.com/stehlegg) - Contributor
- [Thojo0](https://github.com/thojo0) - Contributor
- _Contributors welcome_


License
-------
- This project is distributed under the [MIT License](../master/LICENSE "Read the MIT license")
