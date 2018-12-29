const router = require('koa-router')()

router.get('/', async (ctx) => {
  await ctx.render('home')
})

module.exports = router.routes()