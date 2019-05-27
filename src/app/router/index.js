const router = require('koa-router')()

const home = require('../pages/home')
const project = require('../pages/projects')
const about = require('../pages/about')

router.use('/', home)
router.use('/projects', project)
router.use('/about', about)

module.exports = router