const Koa = require('koa')
const views = require('koa-views')
const path = require('path')
const router = require('../router')
const nunjucks = require('nunjucks')
const admin = require('firebase-admin')
const serviceAccount = require('../serviceAccountKey')
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://insertcode-portfolio-app.firebaseio.com"
})
const firestore = admin.firestore()

const app = new Koa()
const v = path.resolve(__dirname, '../views')
nunjucks.configure(v)
app.use(views(v, {
  map: { njk: 'nunjucks' }
}))

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
