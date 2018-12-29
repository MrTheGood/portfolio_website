const router = require('koa-router')()

const home = require('pages/home')
const project = require('pages/projects')

router.use('/', home)
router.use('/projects', project)

module.exports = router