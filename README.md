# App demo

## Overview

This demo app demonstrate my style and skill of programming.

## Description

Demo app is CLI application that reads a list of posts, comments and users from remote API (https://jsonplaceholder.typicode.com/) 
and store count of relations and „entity“ informations. 
Result is stored in following formats: HTML, JSON, XML. 


## Prerequisites

Installed Docker (https://www.docker.com/) and Git (https://git-scm.com/downloads) on your system.

## Run

- download app with command `git clone https://github.com/lorddesais/demo.git`

- inside `demo` folder run build script (`build.bash`)
	- wait for message `DONE! Container is ready to use!`

- in the same folder run start script (`start.bash`)

Now you can use application with syntax: `php index.php <entity_type> <entity_id> <entity_relation>`, where:
	- `<entity_type>` and `<entity_relation>` is string 'post', 'user' or 'comment'
	- `<entity_id>` is number (min and max value depends on API limits)
App have to be run with all arguments.

## Result

Files with result (`entity.xml`, `entity.json`, `entity.html`) are saved to path `/app/temp/output/<key>/`

## Limitations

App is not absolutely bullet-proof, scalable and complex.
Its just presentation of using different cooperating techniques and several technologies creating meaningful unit.