const router = require('koa-router')()

router.get('/:projectId', async (ctx) => {
  const { projectId } = ctx.params
  await ctx.render('project.njk', { project: projectId })
})

module.exports = router.routes()