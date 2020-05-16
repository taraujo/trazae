const mongoose = require('mongoose');

const UsuarioSchema = new mongoose.Schema({
    nome: String,
    email: String,
    password: String
});

module.exports = mongoose.model('Usuario', UsuarioSchema);