const express = require('express');
const cors = require('cors');
const mongoose = require('mongoose');

const routes = require('./routes');

const app = express();

/**
 * Database Connection
 */
mongoose.connect('mongodb+srv://teste:teste@trazaeappcluster-jb7ku.mongodb.net/test?retryWrites=true&w=majority', {
    useNewUrlParser: true,
    useUnifiedTopology: true,
});

/**
 * Routes
 */
app.use(express.json());
app.use(routes);

/**
 * Cors-Origin
 */
app.use(cors());

app.listen(3333);