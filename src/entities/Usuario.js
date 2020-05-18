const mongoose = require('mongoose');

const UsuarioSchema = new mongoose.Schema({
    name: String,
    email: String,
    password: String
});

module.exports = mongoose.model('Usuario', UsuarioSchema);