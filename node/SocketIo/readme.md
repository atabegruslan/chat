# In Node.js, socket.io can be used.

## Run

1. `npm install`
2. Setup MongoDB
3. `node server.js`
4. Visit: `localhost/chat/node/SocketIo/`
4. Input message text and press enter

### MongoDB

1. Install Mongo: https://docs.mongodb.com/manual/installation/
2. `mkdir C:/data/db`
3. Start Mongo database server: `cd C:/data`, `mongod --dbpath .`. Keep this terminal open.
4. In another terminal:
```
$mongo
> use chat
> db.createCollection("messages")
```

#### Other Notes:

- Show all DB: `show dbs`
- Switch to a DB (create if necessary): `use {database-name}`
- Show all Collections (tables) in a DB: `show collections`
- Delete the database that you are currently in: `db.dropDatabase()`
- Delete a collection: `drop() - db.{collection-name}.drop() `

## Tutorials

- https://www.youtube.com/playlist?list=PLf8BkXI6hjdjVRr2hdHHdCQ_w0MhQgeJQ
