const express = require('express');

const routes = express.Router();

const AuthController = require('./controllers/AuthController');
const UsuarioController = require('./controllers/UsuarioController');

routes.post('/auth', AuthController.auth);

routes.route('/usuarios')
  .get(UsuarioController.show)
  .post(UsuarioController.store)
  .put(UsuarioController.update)
  .delete(UsuarioController.destroy);

  module.exports = routes;