const express = require('express');
const app = express();

const cors = require('cors')
const axios = require('axios');

app.use(cors());

const gifProviderUrl = 'https://api.giphy.com/v1/gifs/trending'
const apiKey = 'MG3zYrqJDdYXUENiamJoW1avccqpBofw'

const gifProviderUrl2 = 'https://g.tenor.com/v1/trending'
const apiKey2 = 'LIVDSRZULELA'

app.get('/api/gifs', (request, response) => {
    axios
        .get(gifProviderUrl, {
            params: {
                q: request.query.q,
                key: apiKey,
                limit: 10
            }
        })
        .then(res => {
            let gifs = res.data
            response.send(gifs)
        })
        .catch(error => {
            response.send(error.message)
        });
})

const port = 3000
app.listen(port)