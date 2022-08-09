const express = require('express');
const app = express();

const cors = require('cors')
const axios = require('axios');

app.use(cors());

const gifProviderUrl = 'https://g.tenor.com/v1/search'
const apiKey = 'LIVDSRZULELA'

app.get('/api/gifs', (request, response) => {
    axios
        .get(gifProviderUrl, {
            params: {
                q: request.query.q,
                key: apiKey,
                limit: 20,
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