const Usuario = require('../entities/Usuario');

module.exports = {
    
    /**
    * @param {Request} request 
    * @param {Response} response 
    */
    index(request, response) {
        return null;
    },

    /**
    * @param {Request} request 
    * @param {Response} response 
    */
    async store(request, response) {
        const { nome, email, password } = request.body;

        try {
            let usuario = await Usuario.findOne({ email });

            if (usuario) {
                return response.status(409)
                    .json({
                        message: 'E-mail já existente!'
                    });
            }

            usuario = await Usuario.create({
                nome, email, password
            }); 

            return response.json(usuario);
        } catch (exception) {
            console.log(exception);
            return response.status(500)
                .send({
                    message: 'Não foi possível cadastrar o usuário!'
                });
        }
    },

    /**
    * @param {Request} request 
    * @param {Response} response 
    */
    async show(request, response) {
        return null;
    },

    /**
    * @param {Request} request 
    * @param {Response} response 
    */
    async update(request, response) {
        return null;
    },

    /**
    * @param {Request} request 
    * @param {Response} response 
    */
    async destroy(request, response) {
        return null;
    },
}