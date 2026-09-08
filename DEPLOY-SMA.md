# MantisBT tester environment

## Quick start

```bash
./tester-env deploy
./tester-env seed
./tester-env verify
./tester-env reset
```

The app listens on `http://localhost:18317/`. The deterministic administrator
is `administrator` / `root`. Use `--port PORT` (or `PORT`) for an isolated host
port. `RUN_ID` scopes only the Compose project and MariaDB volume; `IMAGE_TAG`
selects the source-built image and never incorporates `RUN_ID`.

`deploy` builds editable source, starts PHP/Apache and MariaDB 11.4, runs the
upstream installer with fixed credentials and UTC, then requires HTTP 200 from
`/login_page.php`. `reset` runs project-scoped `docker compose down --volumes`
and does not remove images or shared browser infrastructure.

`seed` creates the deterministic public **Northstar Commerce** project with
Checkout and Account categories, exactly three UTC-dated issues in new,
feedback, and resolved states, and one public triage note. `verify` checks
these exact records through MantisBT's database API.

## Recorded evidence

At upstream `release-2.28.4` (`ceb74c8056753e0d4089af95bde794e47fa2ef53`),
two foreground clean `reset -> deploy -> seed -> verify` cycles succeeded on
port 18317. Browser smoke at `host.docker.internal:18317` showed all three
Northstar Commerce issues in View Issues and the public triage note on issue
0000001. Browser evidence is carried forward; this deployment document does
not run browser automation.
