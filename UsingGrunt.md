Installing Grunt
================

Get 16.14.0 or above but below 17 (as stated in package.json in Moodle's root) from: https://nodejs.org/en/download/releases/ - follow https://github.com/nodejs/node#verifying-binaries if you wish.

On Linux, you can follow https://nodejs.org/en/download/package-manager/ to install via a package manager.

then in a shell (Linux - prefix with 'sudo') / 'Node.js Command prompt' (Windows) in the Moodle root directory:

    [sudo] npm install -g grunt-cli

    [sudo] npm install

Running Grunt
=============

On Linux
--------

Navigate to /blocks/superframe/amd then run:

    grunt amd

in a shell.

On Windows
----------

Edit /.eslintrc and change:

    'linebreak-style': ['error', 'unix'],

to:

    'linebreak-style': ['off', 'unix'],

This is because Git manages this for us with 'AutoCrLf' set to 'true' -> see 'Formatting and Whitespace' on 'https://www.git-scm.com/book/en/v2/Customizing-Git-Git-Configuration'.

To run in the Moodle root:

    grunt amd --root=/blocks/superframe

in the Node.js command prompt.
