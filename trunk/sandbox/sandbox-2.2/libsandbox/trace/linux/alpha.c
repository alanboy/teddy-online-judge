static int trace_sysnum(void)
{
	return do_peekuser(0);	/* register r0 */
}

static long trace_raw_ret(void *vregs)
{
	trace_regs *regs = vregs;
	return regs->r0;
}

static unsigned long trace_arg(void *vregs, int num)
{
	trace_regs *regs = vregs;
	switch (num) {
		case 1: return regs->r16;
		case 2: return regs->r17;
		case 3: return regs->r18;
		case 4: return regs->r19;
		case 5: return regs->r20;
		case 6: return regs->r21;
		default: return -1;
	}
}
