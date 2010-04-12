require 'rubygems'
require 'rake'

task :default => :test

desc "Run all tests"
task :test do
  system "phpunit --colors #{Dir['test/**/*.php'].join(" ")}"
end