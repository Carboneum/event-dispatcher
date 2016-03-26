Event Dispatcher
================

[![Build Status](https://travis-ci.org/Carboneum/event-dispatcher.svg?branch=master)](https://travis-ci.org/Carboneum/event-dispatcher)
[![Code Climate](https://codeclimate.com/github/Carboneum/event-dispatcher/badges/gpa.svg)](https://codeclimate.com/github/Carboneum/event-dispatcher)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Carboneum/event-dispatcher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Carboneum/event-dispatcher/?branch=master)
[![Test Coverage](https://codeclimate.com/github/Carboneum/event-dispatcher/badges/coverage.svg)](https://codeclimate.com/github/Carboneum/event-dispatcher/coverage)
[![Issue Count](https://codeclimate.com/github/Carboneum/event-dispatcher/badges/issue_count.svg)](https://codeclimate.com/github/Carboneum/event-dispatcher)

TODO: document

Library implementing subscriber pattern.

Basics
------

Event to subscriber mapping is based on ```Subscription``` entity that define connection between **event name**
and service call: **service locator** and **method name**.

To use the library in your project you must implement adapter for service call: create a class
implementing ```\Carboneum\EventDispatcher\Service\InvokeAdapterInterface```.

InvokeAdapterInterface
----------------------

Implementation of this interface should handle all architecture-specific work:
 - Loading module, and locating/constructing service
 - Calling service method and passing event object to it


Event models
------------

- Must implement EventInterface
- Can extend Event abstract class
- Should be immutable
