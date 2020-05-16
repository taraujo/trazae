/**
 * Entidades
 */
const Usuario = require('../entities/Usuario');

module.exports = {

    /**
     * O método de autenticação 
     * 
     * @param {Request} request 
     * @param {Response} response 
     */
    async auth(request, response) {
        const { email, password } = request.body;

        try {
            let usuario = await Usuario.findOne({ email, password });

            if (!usuario) {
                return response.status(401)
                    .json({
                        message: 'Falha na autenticação!'
                    });
            }
            
            return response.json(usuario);
        } catch (exception) {
            console.log(exception);
            return response.status(500)
                .send({
                    message: 'Não foi possível autenticar o usuário!'
                });
        }
    }
}