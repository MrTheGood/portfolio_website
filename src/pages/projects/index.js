const router = require('koa-router')()

router.get('/:projectId', async (ctx) => {
  const { projectId } = ctx.params
  await ctx.render('project', { project: projectId })
})

module.exports = router.routes()