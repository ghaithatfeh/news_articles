const express = require('express');
const app = express();

const cors = require('cors')
const axios = require('axios');

app.use(cors());

const gifProviderUrl = 'https://api.giphy.com/v1/gifs/trending'
const apiKey = 'MG3zYrqJDdYXUENiamJoW1avccqpBofw'

const gifProviderUrl2 = 'https://g.tenor.com/v1'
const apiKey2 = 'LIVDSRZULELA'

app.get('/api/gifs/:type', (request, response) => {
    axios
        .get(`${gifProviderUrl2}/${request.params.type}`, {
            params: {
                q: request.query.q,
                key: apiKey2,
                limit: 12,
                media_filter: 'gif,tinygif'
            }
        })
        .then(res => {
            let gifs = res.data.results.map(item => {
                return {
                    id: 1,
                    tinygif_url: item.media[0].tinygif.url,
                    gif_url: item.media[0].gif.url,
                }
            })
            response.send(gifs)
        })
        .catch(error => {
            response.send(error.message)
        });
})

const port = 3000
app.listen(port)