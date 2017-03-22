#!/bin/sh

ack --column \
	--type-add php=.tpl \
	--ignore-dir .browser \
	--ignore-file=is:tags \
	--ignore-file=match:/.*session\.vim/ \
	--ignore-file=match:/.*project\.vim/ \
	--ignore-file=match:/cscope\.*/ \
	--ignore-file=match:/.*\.vims/ \
	--ignore-file=match:/.*\.vimp/ \
	--ignore-dir storage/debugbar \
	"$1"

