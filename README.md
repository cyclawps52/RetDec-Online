
# RetDec-Online

Currently hosted by [Rewzilla](https://github.com/rewzilla) at [retdec.hostbin.org](http://retdec.hostbin.org)

## What is this?

This is an online wrapper for the [RetDec Decompiler](http://github.com/avast-tl/retdec). This is made for ease of access and all rights are reserved to Avast for the actual RetDec source code. 

## What can it do?
The web interface included a sample of command line flags available, including:

- Architecture selection
- Target Endianness
- Raw Entry Point Address
- Function Decompile List
- Range Decompile List
- Keep Unreachable Functions
- Keep Brackets in Generated Code
- Keep Standard Library Functions
- Emit Compound Operators
- Insert IDA Pro Color Tags

After uploading your binary and selecting any options, the interface will

1. Display the result of the decompile command (in case errors/exceptions were thrown)
2. Display the decompiled C source
3. Give the user an option to download said source

## Cleanup/Maintenance

All files are cleared if they are older than 30 minutes by a simple cron job.

> find /var/www/html/uploads/* -mmin +30 -exec rm {} \;
> */10 * * * * /root/removeOldFiles

## Community Support

If you have an idea for making this better, feel free to fork and pull request! This was made for easy access for CTFs and various projects at [DSU](https://dsu.edu) and I am welcome to feedback/ideas.
