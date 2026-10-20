# Changelog

## 2.9.1

- Accept the event dispatcher contract so Laravel EventFake and custom dispatcher adapters can receive committed outcomes. Individual listener isolation applies to the native Laravel dispatcher; adapters control their own listener execution.

## 2.9.0

- Add `EventBus::dispatchAfterCommit()` for minimal domain outcomes. Delivery waits for the owning connection's outer commit and is discarded on rollback.
- Isolate individual listener failures, including wildcard and interface listeners. Log only the stable event key and exception class; logger failures cannot invalidate a committed operation.
- Preserve existing synchronous `dispatch()` and `dispatchByKey()` behavior.
- This synchronous delivery is not an outbox and cannot survive process termination. Services must provide immutable allowlisted payloads and suppress failed or unchanged operations.
