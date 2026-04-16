# vendora
A multi-vendor SaaS platform with payment orchestration and external integration support.


# Our branching strategy going forward
main          ← stable, production-ready code only
develop       ← integration branch
feature/*     ← one branch per feature
fix/*         ← bug fixes

## Start a feature
git checkout -b feature/vendor-panel-views

## Work, then commit in small logical chunks
git add .
git commit -m "feat: add vendor product index blade view"
git commit -m "feat: add vendor product create and edit forms"
git commit -m "feat: add vendor order index and show views"

## Merge back to develop when done
git checkout develop
git merge feature/vendor-panel-views --no-ff
git branch -d feature/vendor-panel-views

<code>--no-ff keeps the merge history clean — you can see exactly which commits belonged to which feature.</code>

