module.exports = {
  apps: [
    {
      name: 'vite-dev',
      script: 'npm',
      args: 'run dev',
      watch: true,
      env: {
        NODE_ENV: 'development',
      }
    }
  ]
};
