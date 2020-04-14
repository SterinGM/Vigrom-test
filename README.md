# Vigrom-test

`SELECT SUM(amount) FROM transaction WHERE reason = 'REFUND' AND created_at > NOW() - interval '7 days';`