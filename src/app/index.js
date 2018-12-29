const Koa = require('Koa')
const views = require('koa-views')
const path = require('path')
const router = require('router')

const app = new Koa()

app.use(views(path.resolve(__dirname, '../views'), {
  map: {
    html: 'nunjucks'
  }
}));

app.use(router.routes())

exports.start = async () => {
  try {
    const port = 3000
    await app.listen(port)
    console.log(`Server is listening on port ${port}`)
  } catch (err) {
    console.log('Something went wrong:', error)
  }
}
