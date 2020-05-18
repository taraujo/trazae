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

app.use(express.json());

/**
 * Cors-Origin
 */
app.use((req, res, next) => {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "*");
    
    app.use(cors());

    return next();
});

/**
 * Routes
 */
app.use(routes);

app.listen(3333);