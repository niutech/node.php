Node.php
========

Ever wanted to deploy a node.js web app but didn't have money for a dedicated node.js hosting or didn't have time to set up a cloud PaaS? Have an existing PHP shared hosting based on the LAMP stack? Now you can run node.js on top of it!

Node.php originates from my ealier [answer on Stack Overflow](http://stackoverflow.com/questions/24777750/how-to-host-a-node-js-application-in-shared-hosting/27391738#27391738).

The node.php script installs an official node.js package, starts a hidden server on localhost:49999 with provided JS file and proxies all requests to it.

### Warning! This is an alpha version, it is unsecure, you run it at your own risk!

Requirements
------------

A PHP web hosting based on Linux with safe mode off and the following functions enabled: `curl_exec`, `exec`, `passthru`.

How to run
----------

Put the `node.php` file in your public_html (or similar) folder, then install node.js by browsing to: `http://example.org/node.php?install`.

When succeeded, you can install your node.js app by uploading its folder or using npm: `http://example.org/node.php?npm=install jt-js-sample`.

When everything goes fine, start your node.js instance by going to: `http://example.org/node.php?start=node_modules/jt-js-sample/index.js`.

Now you can request your app by browsing to: `http://example.org/node.php?path=optional/request/path`. This will return a response from the running node.js app at `http://127.0.0.1:49999/optional/request/path`.

Finally, stop your node.js server by loading: `http://example.org/node.php?stop`.

Commands
--------

`node.php[?path=some/path]` - serves an already running node.js app with an optional request path (no leading slash)

The following commands require the `ADMIN_MODE` set to `true` (line 13 of `node.php`):

`node.php?install` - downloads and extracts node.js into the `node` folder.

`node.php?uninstall` - removes the `node` folder

`node.php?start=node_modules/jt-js-sample/index.js` - starts a node.js server running the provided `index.js` file

`node.php?stop` - stops a running node.js server

`node.php?npm=install jt-js-sample` - runs `npm install jt-js-sample` (*may be dangerous!*)

Demo
----

[Here is a live demo](http://juvenia.info/node_modules/jt-js-sample/) on a dirt cheap PHP shared hosting.

License
-------

Node.js is developed by Joyent et al. under the MIT License.

Node.php is developed by Jerzy Głowacki under the MIT License.