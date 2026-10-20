# Changelog

## 2.10.3

- Construct the named registry through an explicit factory before aliasing typed access, preventing circular resolution. Supersedes the startup regression in 2.10.2.

## 2.10.2

- Unify typed EventRegistry/EventBus resolution with their named singleton bindings so registered definitions work consistently with dispatchByKey and facades.

## 2.10.1

- Attach after-commit callbacks to the owning connection when multiple connections have open transactions; preserve Laravel testing transaction behavior.

## 2.10.0

- Add registered immutable business outcome events with English and Persian discovery metadata.
- Publish minimal allowlisted identifiers after the owning transaction commits; preserve all legacy event signatures and behavior.
- Suppress outcomes for validation failures, rollback and unchanged business state. Listener failures cannot invalidate committed writes. Delivery is synchronous without an outbox.
- Add private persisted-state comparison support for service no-op detection.


## 2.9.1

- Accept the event dispatcher contract so Laravel EventFake and custom dispatcher adapters can receive committed outcomes. Individual listener isolation applies to the native Laravel dispatcher; adapters control their own listener execution.

## 2.9.0

- Add `EventBus::dispatchAfterCommit()` for minimal domain outcomes. Delivery waits for the owning connection's outer commit and is discarded on rollback.
- Isolate individual listener failures, including wildcard and interface listeners. Log only the stable event key and exception class; logger failures cannot invalidate a committed operation.
- Preserve existing synchronous `dispatch()` and `dispatchByKey()` behavior.
- This synchronous delivery is not an outbox and cannot survive process termination. Services must provide immutable allowlisted payloads and suppress failed or unchanged operations.
